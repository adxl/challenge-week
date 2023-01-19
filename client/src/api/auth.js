import { _get, _post } from "./gateway";

export function getCurrentUser() {
  return _get("/me");
}

export function register(data) {
  return _post("/users", data);
}

export function login(data) {
  return _post("/auth", data);
}
