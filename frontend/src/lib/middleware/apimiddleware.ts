import { handleErrorResponse } from '$lib/handlers/errorhandler';

const baseUrl = import.meta.env.VITE_API_URL;

interface SendOptions {
  method: string;
  path: string;
  data?: FormData;
  contentType?: string;
}

async function send({ method, path, data, contentType }: SendOptions) {
  const opts: { method: string; headers: any; body?: any } = {
    method,
    headers: {},
  };

  if (contentType && contentType !== "")
    opts.headers["Content-Type"] = contentType;

  if (data && contentType == "") {
    opts.headers["Accept"] = "application/json";
    opts.body = data;
  } else {
    opts.headers["Accept"] = "application/json";
    opts.body = JSON.stringify(data);
  }

  const token = localStorage.getItem("token");
  if (token) {
    opts.headers["Authorization"] = `Bearer ${token}`;
  }

  const response = await fetch(`${baseUrl}${path}`, opts);

  await handleErrorResponse(response);
  return response;
}

export function get(path: string) {
  return send({ method: "GET", path });
}

export function del(path: string) {
  return send({ method: "DELETE", path });
}

export function post(path: string, data: any, contentType: string) {
  return send({ method: "POST", path, data, contentType });
}

export function put(path: string, data: any, contentType: string) {
  return send({ method: "PUT", path, data, contentType });
}

export function patch(path: string, data: any, contentType: string) {
  return send({ method: "PATCH", path, data, contentType });
}

export async function getFullUrl(path: string) {
  const token = localStorage.getItem("token");
  if (!token) {
    throw new Error("Token not found");
  }
  const response = await fetch(path, {
    method: "GET",
    headers: {
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    },
  });
  return response;
}
