import { _patch, _post } from "./gateway";

export function updateUser(id, data) {
  return _patch("/users/" + id, data);
}

export function updateUserStatus(id, data) {
  return _patch("/users/" + id + "/status", data);
}

export function banUser(id) {
  return _post(`/users/${id}/ban`, {});
}

export function giveRoleAdmin(id) {
  return _post(`/users/${id}/role/admin`, {});
}
