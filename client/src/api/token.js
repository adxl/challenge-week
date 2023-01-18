import { _post } from "./gateway.js";

export function verifyToken(token) {
  return _post("/users/verify/" + token);
}
