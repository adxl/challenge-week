import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllKyc() {
  return _getAll("/kycs");
}

export function getKyc(id) {
  return _get("/kycs/" + id);
}

export function addKyc(data) {
  return _post("/kycs", data);
}

export function updateKyc(id, data) {
  return _patch("/kycs/" + id, data);
}

export function deleteKyc(id) {
  return _delete("/kycs/" + id);
}
