import { writable } from "svelte/store";

interface Alert {
  message: string;
  duration?: number;
  type: "success" | "error" | "info" | "warning";
}

const Alert = writable<Alert>({
  message: "Testing",
  duration: 3000,
  type: "info",
});

export { Alert };
