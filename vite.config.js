import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import dotenv from 'dotenv';

import vueJsx from '@vitejs/plugin-vue-jsx';


dotenv.config();
const MANIFEST_URL = process.env.MANIFEST_URL;
const DEFAULT_PORT = 5173;

const url = MANIFEST_URL ? new URL(MANIFEST_URL) : null;
const host = url ? url.hostname : 'localhost';
const port = url ? url.port || DEFAULT_PORT : DEFAULT_PORT;

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/sass/app.scss',
				'resources/js/app.js',
				
			],
			refresh: true,
		}),
		vue(), vueJsx()
	], 
	build: {
		sourcemap: true, // Enable source maps
	},
	// build: {
		// ssr: true,
		// noExternal: ['vue', '@vue/server-renderer']
		// outDir: 'public/dist',
	// },
	server: {
		host: host,
		port: port,
		hmr: {
			protocol: 'ws',
			host: host,
		},
	},
});