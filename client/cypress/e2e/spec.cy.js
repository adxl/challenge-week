/* eslint-disable */

const CLIENT_EMAIL = "client_3@esgi.fr";
const CLIENT_PASSWORD = "esgi";

const DELIVERER_EMAIL = "deliverer_2@esgi.fr";
const DELIVERER_PASSWORD = "esgi";

const LOGIN_EMAIL_INPUT = '[data-cy="login-email-input"]';
const LOGIN_PASSWORD_INPUT = '[data-cy="login-password-input"]';
const LOGIN_SUBMIT_BUTTON = '[data-cy="login-submit-button"]';

const STORE_PRODUCTS_LIST = '[data-cy="store-products-list"]';
const STORE_ADD_TO_CART_BUTTON = '[data-cy="store-add-to-cart-button"]';

const CART_SUBMIT_BUTTON = '[data-cy="cart-submit-button"]';
const CART_FINAL_SUBMIT_BUTTON = '[data-cy="cart-final-submit-button"]';

const ORDERS_TAKE_BUTTON = '[data-cy="orders-take-button"]';
const ORDERS_CONFIRM_BUTTON = '[data-cy="orders-confirm-button"]';
const ORDERS_LINK = '[data-cy="orders-link"]';
const ORDERS_LEAVE_REVIEW_BUTTON = '[data-cy="orders-leave-review-button"]';

const ORDERS_REVIEW_NOTATION =  '[data-cy="orders-review-notation-4"]';
const ORDERS_REVIEW_COMMENT_INPUT =  '[data-cy="orders-review-comment-input"]';
const ORDERS_REVIEW_SUBMIT_BUTTON =  '[data-cy="orders-review-submit-button"]';

const LOGOUT_BUTTON = '[data-cy="logout-button"]';

describe("Visit the login page", () => {
  it("Should visits the login page", () => {
    cy.visit("http://localhost:3000/login");

    // login as client
    cy.get(LOGIN_EMAIL_INPUT).type(CLIENT_EMAIL);
    cy.get(LOGIN_EMAIL_INPUT).should("have.value", CLIENT_EMAIL);
    cy.get(LOGIN_PASSWORD_INPUT).type(CLIENT_PASSWORD);
    cy.get(LOGIN_PASSWORD_INPUT).should("have.value", CLIENT_PASSWORD);
    cy.get(LOGIN_SUBMIT_BUTTON).click();

    // add first item to cart
    cy.get(STORE_ADD_TO_CART_BUTTON).first().click();

    // go to cart
    cy.visit("http://localhost:3000/cart");

    // confirm cart
    cy.get(CART_SUBMIT_BUTTON).click();
    cy.get(CART_FINAL_SUBMIT_BUTTON).click();

    // logout
    cy.get(LOGOUT_BUTTON).click();

    // login as deliverer
    cy.get(LOGIN_EMAIL_INPUT).type(DELIVERER_EMAIL);
    cy.get(LOGIN_EMAIL_INPUT).should("have.value", DELIVERER_EMAIL);
    cy.get(LOGIN_PASSWORD_INPUT).type(DELIVERER_PASSWORD);
    cy.get(LOGIN_PASSWORD_INPUT).should("have.value", DELIVERER_PASSWORD);
    cy.get(LOGIN_SUBMIT_BUTTON).click();

    // take care of order
    cy.get(ORDERS_TAKE_BUTTON).first().click();
    // confirm order delivery
    cy.get(ORDERS_CONFIRM_BUTTON).first().click();

    // logout
    cy.get(LOGOUT_BUTTON).click();

    // login as client again
    cy.get(LOGIN_EMAIL_INPUT).type(CLIENT_EMAIL);
    cy.get(LOGIN_EMAIL_INPUT).should("have.value", CLIENT_EMAIL);
    cy.get(LOGIN_PASSWORD_INPUT).type(CLIENT_PASSWORD);
    cy.get(LOGIN_PASSWORD_INPUT).should("have.value", CLIENT_PASSWORD);
    cy.get(LOGIN_SUBMIT_BUTTON).click();

    // go to orders
    cy.get(ORDERS_LINK).click()
    cy.get(ORDERS_LEAVE_REVIEW_BUTTON).first().click()

    // leave a review
    cy.get(ORDERS_REVIEW_NOTATION).click()
    cy.get(ORDERS_REVIEW_COMMENT_INPUT).type('WOAAAAOAOOOUUUH TROP BIENNN !!!')
    cy.get(ORDERS_REVIEW_SUBMIT_BUTTON).click()
  });
});
