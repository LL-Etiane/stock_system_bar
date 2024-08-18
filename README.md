# Simple Stock Managment system for those selling drinks
### Considerations
- Products can be purchased at different prices but thier sale price is relatively fixed but there is a posibility they can change after a while.
- Stocks are recorded as either entry, exit or damages
- When registering stock entry, you can set the salling price for that stock or the previosly set selling price will be used if its exist. If not, you will have to set it.
- Stock reports can be generated weekly or monthly (a possibility will be added to make it such that it can be generated on selected time interval)
- So we have the following tables
    - products
        - id
        - name

    - stocks
        - id
        - product_id
        - quantity
        - type => entry, exit, damage

    - prices
        - id
        - product_id
        - stock_id
        - purchase_price
        - selling_price

    On the stock sheet, The stock on monday, cotains the brought forward and any other stock for that day