import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllProductType() {
  return _getAll("/product_types");
}

export function getProductType(id) {
  return _get("/product_types/" + id);
}

export function addProductType({ name, unit, label }) {
  const data = { name, unit, label };
  return _post("/product_types", data);
}

export function updateProductType(id, { name, unit, label }) {
  const data = { name, unit, label };
  return _patch("/product_types/" + id, data);
}

export function deleteProductType(id) {
  return _delete("/product_types/" + id);
}
