import { COOKIE_NAME } from "@shared/const";
import { getSessionCookieOptions } from "./_core/cookies";
import { systemRouter } from "./_core/systemRouter";
import { publicProcedure, router, protectedProcedure } from "./_core/trpc";
import { getAllSensors, getAllActuators, getActuatorById } from "./db";
import { controlActuator } from "./mqtt";
import { z } from "zod";

export const appRouter = router({
  // if you need to use socket.io, read and register route in server/_core/index.ts, all api should start with '/api/' so that the gateway can route correctly
  system: systemRouter,
  auth: router({
    me: publicProcedure.query(opts => opts.ctx.user),
    logout: publicProcedure.mutation(({ ctx }) => {
      const cookieOptions = getSessionCookieOptions(ctx.req);
      ctx.res.clearCookie(COOKIE_NAME, { ...cookieOptions, maxAge: -1 });
      return {
        success: true,
      } as const;
    }),
  }),

  // IoT Sensors and Actuators
  iot: router({
    sensors: router({
      list: publicProcedure.query(async () => {
        return getAllSensors();
      }),
    }),
    actuators: router({
      list: publicProcedure.query(async () => {
        return getAllActuators();
      }),
      control: protectedProcedure
        .input(
          z.object({
            actuatorId: z.number(),
            command: z.enum(["on", "off"]),
          })
        )
        .mutation(async ({ input }) => {
          try {
            await controlActuator(input.actuatorId, input.command);
            return { success: true };
          } catch (error) {
            console.error("Error controlling actuator:", error);
            throw error;
          }
        }),
    }),
  }),
});

export type AppRouter = typeof appRouter;
