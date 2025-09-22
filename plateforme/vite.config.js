import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                
                "resources/css/admin-entrainement.css",
                "resources/css/admin-gestion-user.css",
                "resources/css/admin-stats.css",
                "resources/css/app.css",
                "resources/css/choix_test.css",
                "resources/css/comprehension_ecrite.css",
                "resources/css/custom.css",
                "resources/css/dashboard-client.css",
                "resources/css/expression_ecrite.css",
                "resources/css/myExpressionEcrite.css",
                "resources/css/suggestion.css",

                "resources/sass/app.scss",
                "resources/js/admin-stats.js",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
                "resources/js/comprehension_ecrite.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
