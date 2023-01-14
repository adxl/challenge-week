/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution");

module.exports = {
    root: true,
    rules: {
        'tabs': 1,
        "indent": ["error", 2]
    },
    extends: [
        "plugin:vue/vue3-essential",
        "eslint:recommended",
        "@vue/eslint-config-prettier",
    ],
    parserOptions: {
        ecmaVersion: "latest",
    },
};
