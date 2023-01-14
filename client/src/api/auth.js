import { _get, _post } from "./gateway";

export function getCurrentUser() {
  return _get("/me");
}

export function register({ name, email, password }) {
  const data = { name, email, password };
  return _post("/users", data);
}

export function login({ email, password }) {
  const data = { email, password };
  return _post("/auth", data);
}
