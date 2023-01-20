import { _get, _getAll } from "./gateway";

export function getAllOrders() {
  return _getAll("/orders");
}

export function getOrder(id) {
  return _get("/orders/" + id);
}
