import { eq } from "drizzle-orm";
import { drizzle } from "drizzle-orm/mysql2";
import { InsertUser, users, sensors, actuators, InsertSensor, InsertActuator } from "../drizzle/schema";
import { ENV } from './_core/env';

let _db: ReturnType<typeof drizzle> | null = null;

// Lazily create the drizzle instance so local tooling can run without a DB.
export async function getDb() {
  if (!_db && process.env.DATABASE_URL) {
    try {
      _db = drizzle(process.env.DATABASE_URL);
    } catch (error) {
      console.warn("[Database] Failed to connect:", error);
      _db = null;
    }
  }
  return _db;
}

export async function upsertUser(user: InsertUser): Promise<void> {
  if (!user.openId) {
    throw new Error("User openId is required for upsert");
  }

  const db = await getDb();
  if (!db) {
    console.warn("[Database] Cannot upsert user: database not available");
    return;
  }

  try {
    const values: InsertUser = {
      openId: user.openId,
    };
    const updateSet: Record<string, unknown> = {};

    const textFields = ["name", "email", "loginMethod"] as const;
    type TextField = (typeof textFields)[number];

    const assignNullable = (field: TextField) => {
      const value = user[field];
      if (value === undefined) return;
      const normalized = value ?? null;
      values[field] = normalized;
      updateSet[field] = normalized;
    };

    textFields.forEach(assignNullable);

    if (user.lastSignedIn !== undefined) {
      values.lastSignedIn = user.lastSignedIn;
      updateSet.lastSignedIn = user.lastSignedIn;
    }
    if (user.role !== undefined) {
      values.role = user.role;
      updateSet.role = user.role;
    } else if (user.openId === ENV.ownerOpenId) {
      values.role = 'admin';
      updateSet.role = 'admin';
    }

    if (!values.lastSignedIn) {
      values.lastSignedIn = new Date();
    }

    if (Object.keys(updateSet).length === 0) {
      updateSet.lastSignedIn = new Date();
    }

    await db.insert(users).values(values).onDuplicateKeyUpdate({
      set: updateSet,
    });
  } catch (error) {
    console.error("[Database] Failed to upsert user:", error);
    throw error;
  }
}

export async function getUserByOpenId(openId: string) {
  const db = await getDb();
  if (!db) {
    console.warn("[Database] Cannot get user: database not available");
    return undefined;
  }

  const result = await db.select().from(users).where(eq(users.openId, openId)).limit(1);

  return result.length > 0 ? result[0] : undefined;
}

/**
 * Get all sensors
 */
export async function getAllSensors() {
  const db = await getDb();
  if (!db) return [];
  return db.select().from(sensors);
}

/**
 * Get sensor by ID
 */
export async function getSensorById(id: number) {
  const db = await getDb();
  if (!db) return null;
  const result = await db.select().from(sensors).where(eq(sensors.id, id)).limit(1);
  return result.length > 0 ? result[0] : null;
}

/**
 * Get all actuators
 */
export async function getAllActuators() {
  const db = await getDb();
  if (!db) return [];
  return db.select().from(actuators);
}

/**
 * Get actuator by ID
 */
export async function getActuatorById(id: number) {
  const db = await getDb();
  if (!db) return null;
  const result = await db.select().from(actuators).where(eq(actuators.id, id)).limit(1);
  return result.length > 0 ? result[0] : null;
}

/**
 * Create a new sensor
 */
export async function createSensor(sensor: InsertSensor) {
  const db = await getDb();
  if (!db) throw new Error("Database not available");
  await db.insert(sensors).values(sensor);
}

/**
 * Create a new actuator
 */
export async function createActuator(actuator: InsertActuator) {
  const db = await getDb();
  if (!db) throw new Error("Database not available");
  await db.insert(actuators).values(actuator);
}
