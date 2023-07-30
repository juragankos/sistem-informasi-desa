import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/colorbox.css",
                "resources/css/first.css",
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                { src: "node_modules/font-awesome/css/font-awesome.min.css", dest: "vendors/fontawesome/css" },
                { src: "node_modules/font-awesome/fonts", dest: "vendors/fontawesome" },

                { src: "node_modules/jquery-colorbox/jquery.colorbox-min.js", dest: "vendors" },
                { src: "node_modules/jquery/jquery.min.*", dest: "vendors" },
            ],
        }),
    ],
});