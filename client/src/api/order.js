import { _get, _getAll, _post, _patch } from "./gateway";

export function getAllOrders() {
  return _getAll("/orders");
}

export function getOrder(id) {
  return _get("/orders/" + id);
}

export function createOrder(order) {
  return _post("/orders", order);
}

export function takeOrder(id, deliverer) {
  return _patch("/orders/" + id, {
    deliverer: "/users/" + deliverer,
    status: "SHIPPING",
  });
}
