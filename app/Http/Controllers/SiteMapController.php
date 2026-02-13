<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Page;

class SiteMapController extends Controller
{
    public function generateSitemap()
    {
        $this->generateProductSitemap();
        $this->generatePageSitemap();
        $this->generateBlogSitemap();
        $this->generateMasterSitemap();

		return redirect(Storage::disk('public')->url('sitemap.xml'));
    }

    private function generateProductSitemap()
    {
        $products = Product::all();
        $chunkSize = 500; // Number of products per sitemap file
        $chunks = $products->chunk($chunkSize);
        $index = 1;

        foreach ($chunks as $chunk) {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($chunk as $product) {
                $xml .= '<url>
                            <loc>' . env('APP_URL') . '/product/' . $product->slug . '</loc>
                            <priority>0.9</priority>
                            <lastmod>' . $product->updated_at->format('Y-m-d') . '</lastmod>
                        </url> ';
            }

            $xml .= '</urlset>';

            // Save the sitemap to the storage directory
            Storage::disk('public')->put("sitemap-products{$index}.xml", $xml);
            $index++;
        }
    }

    private function generatePageSitemap()
    {
        $pages = Page::all();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($pages as $page) {
            $xml .= '<url>
                        <loc>' . env('APP_URL') . '/page/' . $page->slug . '</loc>
                        <priority>0.9</priority>
                        <lastmod>' . $page->updated_at->format('Y-m-d') . '</lastmod>
                    </url> ';
        }

        $xml .= '</urlset>';

        // Save the sitemap to the storage directory
        Storage::disk('public')->put('sitemap-pages.xml', $xml);
    }

    private function generateBlogSitemap()
    {
        $blogs = Blog::all();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($blogs as $blog) {
            $xml .= '<url>
                        <loc>' . env('APP_URL') . '/blog-details/' . $blog->slug . '</loc>
                        <priority>0.8</priority>
                        <lastmod>' . $blog->updated_at->format('Y-m-d') . '</lastmod>
                    </url> ';
        }

        $xml .= '</urlset>';

        // Save the sitemap to the storage directory
        Storage::disk('public')->put('sitemap-blogs.xml', $xml);
    }

    private function generateMasterSitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add product sitemaps
        $index = 1;
        while (Storage::disk('public')->exists("sitemap-products{$index}.xml")) {
            $xml .= '<sitemap>
                        <loc>' . env('APP_URL') . '/storage/sitemap-products' . $index . '.xml</loc>
                        <lastmod>' . Carbon::now()->format('Y-m-d') . '</lastmod>
                    </sitemap>';
            $index++;
        }

        // Add page sitemap
        $xml .= '<sitemap>
                    <loc>' . env('APP_URL') . '/storage/sitemap-pages.xml</loc>
                    <lastmod>' . Carbon::now()->format('Y-m-d') . '</lastmod>
                </sitemap>';

        // Add blog sitemap
        $xml .= '<sitemap>
                    <loc>' . env('APP_URL') . '/storage/sitemap-blogs.xml</loc>
                    <lastmod>' . Carbon::now()->format('Y-m-d') . '</lastmod>
                </sitemap>';

        $xml .= '</sitemapindex>';

        // Save the master sitemap to the storage directory
        Storage::disk('public')->put('sitemap.xml', $xml);
    }
}
