import axios from "axios";

axios.interceptors.response.use(
  function (response) {
    return response;
  },
  function (error) {
    if (error?.response?.status === 401) {
      sessionStorage.removeItem("cw-app-token");
      window.location.href = "/login";
    }
    return Promise.reject(error);
  }
);

const URL = import.meta.env.VITE_API_URL;

function get_headers() {
  const headers = {
    "Content-Type": "application/json",
  };

  const token = JSON.parse(sessionStorage.getItem("cw-app-token"));

  if (token) {
    headers["Authorization"] = "Bearer " + token;
  }

  return headers;
}

export async function _getAll(path) {
  const headers = get_headers();
  headers["Content-Type"] = "application/ld-json";
  const response = await axios.get(URL + path, { headers });
  response.data.items = response.data["hydra:member"];
  return response;
}

export async function _get(path) {
  const headers = get_headers();
  headers["Content-Type"] = "application/ld-json";
  const response = await axios.get(URL + path, { headers });
  return response;
}

export function _post(path, body) {
  const headers = get_headers();
  headers["Content-Type"] = "application/json";
  return axios.post(URL + path, body, { headers });
}

export function _patch(path, body) {
  const headers = get_headers();
  headers["Content-Type"] = "application/merge-patch+json";
  return axios.patch(URL + path, body, { headers });
}

export function _delete(path) {
  const headers = get_headers();
  return axios.delete(URL + path, { headers });
}
