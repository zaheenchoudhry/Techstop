Website is fully functional with the following extra features:
   - Products on Sale
   - Pre-order Products
   - Feedback/Links
   - Soting Porducts
   - Related products on product pages
   - Checks if you try to checkout more quantity than is in stock

Adrian
   - Inventory.txt
   - Most of the SQL related programming
   - Pop-up functionallity
   - CSS

Zaheen
   - Sliding animation on homepage
   - Most of the CSS related programming
   - Pop-up design
   - SQL

Savindi
   - nothing...?

When adding new products:

   To add a product on sale:
      - Put the discounted/cheaper price in the price column
      and put the original price in a new, 8th column

   To add a future product:
      - Make the productID > 9000
      - Put the product image in the FuterProducts folder inside the ProductsImages folder
      Note: Stock will be ignored for future products and it is not necessary to set a stock amount.
      
   For best results, please do the following when adding any new products:
      - include a picture of the product (prefferably same height and width)
      - If the product is in a new department, please put an image for the department 
      in the DepartmentIcons folder (prefferably same height and width)
      - If the product is a new brand please put a logo of the brand in the
      BrandLogos folder (prefferably same height and width)

Other Notes:
   - The inventory.txt file use the character | as its seperator character (not ,)
   - Option to return items is located in bottom right of the footer
   - Our website has a repeated validation error since we put divs
   inside of input labels.