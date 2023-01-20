import { _patch } from "./gateway";

export function updateUser(id, data) {
  return _patch("/users/" + id, data);
}
