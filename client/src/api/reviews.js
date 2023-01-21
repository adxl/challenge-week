import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllProductReviews() {
  return _getAll("/product_reviews");
}

export function getAllDelivererReviews() {
  return _getAll("/deliverer_reviews");
}

// data : { originOrder: IRI, rating: Number, comment: String };
export function sendDelivererReview(data) {
  return _post("/deliverer_reviews", data);
}

// review : id
// data : { originOrder: IRI, product: IRI, rating: Boolean };
export function sendProductReview(id, data) {
  console.log({ id, data });
  return _patch("/product_reviews/" + id, data);
}
