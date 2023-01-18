import { _get } from "./gateway";

export function getAllProductType() {
  return _get("/product_types");
}
