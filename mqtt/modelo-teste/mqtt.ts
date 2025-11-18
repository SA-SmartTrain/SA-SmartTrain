import mqtt, { MqttClient } from "mqtt";
import { getDb } from "./db";
import { sensors, actuators } from "../drizzle/schema";
import { eq } from "drizzle-orm";

let mqttClient: MqttClient | null = null;

const MQTT_BROKER_URL = process.env.MQTT_BROKER_URL || "mqtt://test.mosquitto.org:1883";
const MQTT_CLIENT_ID = `mqtt-dashboard-${Date.now()}`;

/**
 * Initialize MQTT connection and set up message handlers
 */
export async function initMqtt() {
  if (mqttClient && mqttClient.connected) {
    return mqttClient;
  }

  try {
    mqttClient = mqtt.connect(MQTT_BROKER_URL, {
      clientId: MQTT_CLIENT_ID,
      clean: true,
      reconnectPeriod: 1000,
    });

    mqttClient.on("connect", () => {
      console.log("[MQTT] Connected to broker");
      subscribeToAllSensors();
    });

    mqttClient.on("message", async (topic: string, message: Buffer) => {
      const payload = message.toString();
      console.log(`[MQTT] Received message on ${topic}: ${payload}`);
      await updateSensorStatus(topic, payload);
    });

    mqttClient.on("error", (error) => {
      console.error("[MQTT] Connection error:", error);
    });

    mqttClient.on("disconnect", () => {
      console.log("[MQTT] Disconnected from broker");
    });

    return mqttClient;
  } catch (error) {
    console.error("[MQTT] Failed to initialize:", error);
    throw error;
  }
}

/**
 * Subscribe to all sensor topics in the database
 */
async function subscribeToAllSensors() {
  if (!mqttClient) return;

  try {
    const db = await getDb();
    if (!db) return;

    const allSensors = await db.select().from(sensors);

    for (const sensor of allSensors) {
      mqttClient.subscribe(sensor.topic, (err) => {
        if (err) {
          console.error(`[MQTT] Failed to subscribe to ${sensor.topic}:`, err);
        } else {
          console.log(`[MQTT] Subscribed to ${sensor.topic}`);
        }
      });
    }
  } catch (error) {
    console.error("[MQTT] Error subscribing to sensors:", error);
  }
}

/**
 * Update sensor status in the database when a message is received
 */
async function updateSensorStatus(topic: string, payload: string) {
  try {
    const db = await getDb();
    if (!db) return;

    // Determine status based on payload
    const status = payload.toLowerCase() === "on" || payload === "1" ? "on" : "off";

    // Update sensor status
    await db
      .update(sensors)
      .set({
        status,
        lastValue: payload,
        lastUpdated: new Date(),
      })
      .where(eq(sensors.topic, topic));
  } catch (error) {
    console.error("[MQTT] Error updating sensor status:", error);
  }
}

/**
 * Publish a message to an MQTT topic
 */
export async function publishMessage(topic: string, message: string): Promise<void> {
  if (!mqttClient || !mqttClient.connected) {
    throw new Error("MQTT client not connected");
  }

  return new Promise((resolve, reject) => {
    mqttClient!.publish(topic, message, { qos: 1 }, (err) => {
      if (err) {
        console.error(`[MQTT] Failed to publish to ${topic}:`, err);
        reject(err);
      } else {
        console.log(`[MQTT] Published to ${topic}: ${message}`);
        resolve();
      }
    });
  });
}

/**
 * Control an actuator by publishing a message
 */
export async function controlActuator(
  actuatorId: number,
  command: "on" | "off"
): Promise<void> {
  try {
    const db = await getDb();
    if (!db) throw new Error("Database not available");

    // Get actuator from database
    const actuator = await db.select().from(actuators).where(eq(actuators.id, actuatorId)).limit(1);

    if (!actuator || actuator.length === 0) {
      throw new Error("Actuator not found");
    }

    const act = actuator[0];

    // Publish command to MQTT
    await publishMessage(act.topic, command === "on" ? "1" : "0");

    // Update actuator status in database
    await db
      .update(actuators)
      .set({
        status: command,
        updatedAt: new Date(),
      })
      .where(eq(actuators.id, actuatorId));
  } catch (error) {
    console.error("[MQTT] Error controlling actuator:", error);
    throw error;
  }
}

/**
 * Get MQTT client instance
 */
export function getMqttClient(): MqttClient | null {
  return mqttClient;
}

/**
 * Close MQTT connection
 */
export async function closeMqtt(): Promise<void> {
  if (mqttClient) {
    return new Promise((resolve) => {
      mqttClient!.end(() => {
        console.log("[MQTT] Connection closed");
        mqttClient = null;
        resolve();
      });
    });
  }
}
