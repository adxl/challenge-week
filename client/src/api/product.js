import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllProducts() {
  return _getAll("/products");
}

export function getProduct(id) {
  return _get("/products/" + id);
}

export function addProduct(data) {
  return _post("/products", data);
}

export function updateProduct(id, data) {
  return _patch("/products/" + id, data);
}

export function deleteProduct(id) {
  return _delete("/products/" + id);
}
