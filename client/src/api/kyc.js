import { _get, _getAll, _post, _patch, _delete } from "./gateway";

export function getAllKyc() {
  return _getAll("/kycs");
}

export function getPendingKyc() {
  return _getAll("/kycs?status=PENDING");
}

export function getValidatedKyc() {
  return _getAll("/kycs?status=VALIDATED");
}

export function getRefusedKyc() {
  return _getAll("/kycs?status=REFUSED");
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
