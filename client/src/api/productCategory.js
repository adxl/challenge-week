import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllProductCategory() {
  return _getAll("/product_categories");
}

export function getProductCategory(id) {
  return _get("/product_categories/" + id);
}

export function addProductCategory(data) {
  return _post("/product_categories", data);
}

export function updateProductCategory(id, data) {
  return _patch("/product_categories/" + id, data);
}

export function deleteProductCategory(id) {
  return _delete("/product_categories/" + id);
}
