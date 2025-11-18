import { int, mysqlEnum, mysqlTable, text, timestamp, varchar } from "drizzle-orm/mysql-core";

/**
 * Core user table backing auth flow.
 * Extend this file with additional tables as your product grows.
 * Columns use camelCase to match both database fields and generated types.
 */
export const users = mysqlTable("users", {
  /**
   * Surrogate primary key. Auto-incremented numeric value managed by the database.
   * Use this for relations between tables.
   */
  id: int("id").autoincrement().primaryKey(),
  /** Manus OAuth identifier (openId) returned from the OAuth callback. Unique per user. */
  openId: varchar("openId", { length: 64 }).notNull().unique(),
  name: text("name"),
  email: varchar("email", { length: 320 }),
  loginMethod: varchar("loginMethod", { length: 64 }),
  role: mysqlEnum("role", ["user", "admin"]).default("user").notNull(),
  createdAt: timestamp("createdAt").defaultNow().notNull(),
  updatedAt: timestamp("updatedAt").defaultNow().onUpdateNow().notNull(),
  lastSignedIn: timestamp("lastSignedIn").defaultNow().notNull(),
});

export type User = typeof users.$inferSelect;
export type InsertUser = typeof users.$inferInsert;

/**
 * Sensors table for storing IoT sensor information
 */
export const sensors = mysqlTable("sensors", {
  id: int("id").autoincrement().primaryKey(),
  name: varchar("name", { length: 255 }).notNull(),
  topic: varchar("topic", { length: 255 }).notNull().unique(),
  type: varchar("type", { length: 64 }).notNull(), // temperature, humidity, motion, light, etc
  status: varchar("status", { length: 64 }).default("unknown").notNull(), // on, off, unknown
  lastValue: text("lastValue"), // Last received value
  lastUpdated: timestamp("lastUpdated"),
  createdAt: timestamp("createdAt").defaultNow().notNull(),
  updatedAt: timestamp("updatedAt").defaultNow().onUpdateNow().notNull(),
});

export type Sensor = typeof sensors.$inferSelect;
export type InsertSensor = typeof sensors.$inferInsert;

/**
 * Actuators table for storing IoT actuator information (LEDs, relays, etc)
 */
export const actuators = mysqlTable("actuators", {
  id: int("id").autoincrement().primaryKey(),
  name: varchar("name", { length: 255 }).notNull(),
  topic: varchar("topic", { length: 255 }).notNull().unique(),
  type: varchar("type", { length: 64 }).notNull(), // led, relay, pump, etc
  status: varchar("status", { length: 64 }).default("off").notNull(), // on, off
  createdAt: timestamp("createdAt").defaultNow().notNull(),
  updatedAt: timestamp("updatedAt").defaultNow().onUpdateNow().notNull(),
});

export type Actuator = typeof actuators.$inferSelect;
export type InsertActuator = typeof actuators.$inferInsert;