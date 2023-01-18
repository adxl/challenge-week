import axios from "axios";

const URL = import.meta.env.VITE_API_URL;
const token = "";

function get_headers() {
  const headers = {
    "Content-Type": "application/json",
  };

  if (token) {
    headers["Authorization"] = token;
  }

  return headers;
}

export async function _getAll(path) {
  const headers = get_headers(token);
  headers["Content-Type"] = "application/ld-json";
  const response = await axios.get(URL + path, { headers });
  response.data.items = response.data["hydra:member"];
  return response;
}

export async function _get(path) {
  const headers = get_headers(token);
  headers["Content-Type"] = "application/ld-json";
  const response = await axios.get(URL + path, { headers });
  response.data.items = response.data;
  return response;
}

export function _post(path, body) {
  const headers = get_headers(token);
  headers["Content-Type"] = "application/json";
  return axios.post(URL + path, body, { headers });
}

export function _patch(path, body) {
  const headers = get_headers(token);
  headers["Content-Type"] = "application/merge-patch+json";
  return axios.patch(URL + path, body, { headers });
}

export function _delete(path) {
  const headers = get_headers(token);
  return axios.delete(URL + path, { headers });
}
