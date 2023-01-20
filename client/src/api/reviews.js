import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllProductReviews() {
  return new Promise((r) => r([]));
  // return _getAll("/product_reviews");
}

export function getAllDelivererReviews() {
  return _getAll("/deliverer_reviews");
}
