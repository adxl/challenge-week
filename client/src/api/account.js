import { _patch, _post, _getAll } from "./gateway.js";

export function verifyToken(token) {
  return _post("/users/verify/" + token);
}

export function resetPasswordMail(email) {
  return _post("/users/reset-password", { email });
}

export function resetPassword(token, password) {
  return _patch("/users/reset-password/" + token, { password });
}

export function getClients() {
  return _getAll("/users/clients");
}

export function getDeliverers() {
  return _getAll("/users/deliverers");
}
