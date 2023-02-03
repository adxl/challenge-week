export const REGISTER_CLIENT = Symbol();
export const REGISTER_DELIVERER = Symbol();

export const PROFIL_DELIVERER = Symbol();
export const PROFIL_USER = Symbol();
export const PROFIL_CLIENT = Symbol();

export const USER_STATUS = {
  ACTIVE: "ACTIVE",
  INACTIVE: "INACTIVE",
  OPERATIVE: "OPERATIVE",
  SUSPENDED: "SUSPENDED",
  BANNED: "BANNED",
};

export const USER_ROLES = {
  ROLE_ADMIN: "ROLE_ADMIN",
  ROLE_CLIENT: "ROLE_CLIENT",
  ROLE_DELIVERER: "ROLE_DELIVERER",
};

export const ORDER_STATUS = {
  PENDING: "PENDING",
  SHIPPING: "SHIPPING",
  DONE: "DONE",
};
