import { _get, _getAll, _post, _patch } from "./gateway";

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

export function getKyc(pathId) {
  return _get(pathId);
}

export function addKyc(data) {
  return _post("/kycs", data);
}

export function updateKyc(id, data) {
  return _patch("/kycs/" + id, data);
}
