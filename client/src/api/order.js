import { _getAll } from "./gateway";

export function getAllOrders() {
  return _getAll("/orders");
}
