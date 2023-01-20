import { _get, _getAll, _patch } from "./gateway";

export function getAllOrders() {
  return _getAll("/orders");
}

export function getOrder(id) {
  return _get("/orders/" + id);
}

export function takeOrder(id, deliverer) {
  return _patch("/orders/" + id, {
    deliverer: "/users/" + deliverer,
    status: "SHIPPING",
  });
}
