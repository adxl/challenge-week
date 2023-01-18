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

  console.log(headers);
  return headers;
}

export function _get(path) {
  const headers = get_headers(token);
  return axios.get(URL + path, { headers });
}

export function _post(path, body) {
  const headers = get_headers(token);
  return axios.post(URL + path, body, { headers });
}

export function _patch(path, body) {
  const headers = get_headers(token);
  return axios.patch(URL + path, body, { headers });
}

export function _delete(path) {
  const headers = get_headers(token);
  return axios.delete(URL + path, { headers });
}
