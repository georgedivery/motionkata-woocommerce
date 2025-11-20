# Webbeb Theme
Custom WordPress theme designed to work with the ACF plugin.
-- The theme use PSR-2 Coding Standard

## Installation

1. Upload and activate the theme in WordPress admin panel.
2. Install and activate the required plugins:
   - **Advanced Custom Fields PRO** (required)
   - **ACF to REST API** (required)
   - ACF Content Analysis for Yoast SEO (optional)
   - Laravel DD for WordPress (optional)
   - Yoast SEO (optional)
   - Disable Gutenberg (optional)
   
   *Note: The required plugins will be automatically detected. Go to WordPress Admin > Install Plugins to install and activate them.*
3. Import ACF fields:
   - Go to **Custom Fields > Tools > Import**
   - Upload the `acf-export.json` file from `/sync/` folder
   - Select all field groups and click "Import"
   
   *Note: If you don't have the export file, export your ACF fields to `/sync/acf-export.json` using **Custom Fields > Tools > Export**.*

4. Configure WooCommerce pages (Cart and Checkout):
   
   **Important:** The theme uses custom WooCommerce templates instead of block-based cart and checkout. After installing WooCommerce, you need to manually update the Cart and Checkout pages:
   
   - Go to **Pages** in WordPress admin
   - Edit the **Cart** page:
     - Remove any `<!-- wp:woocommerce/cart -->` blocks
     - Add a **Shortcode** block with: `[woocommerce_cart]`
     - Save/Update the page
   
   - Edit the **Checkout** page:
     - Remove any `<!-- wp:woocommerce/checkout -->` blocks
     - Add a **Shortcode** block with: `[woocommerce_checkout]`
     - Save/Update the page
   
   *Note: The theme automatically disables block-based cart and checkout via code, but the page content must be manually updated to use shortcodes instead of blocks.*

## Workflow
1. `git clone` or `git pull origin master`
2. `git checkout -b feature/{Task Number}` - for bugs `bug/{Task Number}`
3. Do your work...
4. Commit your changes - be explicit (Ask yourself what work was done in this files if the answer is too long split the files to different commits).
5. Export and commit your ACF changes in `/sync/export.json` file.
6. `git pull origin master`
7. `git push origin feature/{Task Number}`
8. Go to github.com and create a pull request (PR).
 