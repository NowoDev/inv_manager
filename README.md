<p align="center">

# Favour's Inventory Manager

</p>

## Installation

Clone the repo

`git clone https://github.com/NowoDev/inv_manager.git`

Navigate into the folder `inv_manager`

Run the migrations and seed the database

`php artisan migrate --seed`

Serve the project locally

`php artisan serve`

## Usage

#### Note that only authenticated users can perform any operation, no matter how basic.

### Authentication Endpoints

```  
    [POST] Register:                    /api/register
    [POST] Login:                       /api/login
```

The registration endpoint accepts 5 values:

```
    name,                               // string
    email,                              // email
    password,                           // var_char
    confirm_password,                   // var_char
    role                                // 'Admin' or 'Guest'  
```

The login endpoint accepts 2 values:

```
    email, 
    password
```

Upon Registration or Login, a JWT is generated and this can be used in Postman to test each inventory endpoint

### Inventory Endpoints

```
    [POST] Create:                      /api/inventory
    [GET] Fetch/Read All Inventory:     /api/inventory
    [GET] Fetch/Read Single Inventory:  /api/inventory/{id}
    [PUT] Update Inventory:             /api/inventory/{id}?name=$name&price=$price&quantity=$quantity
    [DEL] Delete Inventory:             /api/inventory/{id}
```

The `CREATE`, and `UPDATE` endpoints accept 3 values:

```
    name,                               // string
    price,                              // integer
    quantity,                           // integer
```

Only the `Admin` can `CREATE`, `READ/VIEW`, `EDIT/UPDATE`, and `DELETE` an inventory while `Guests` can only `READ/VIEW`
an inventory.

### Cart Endpoint

```
    [POST] Add Item to Cart             /api/cart/{inventory_id}
```

The Cart endpoint also accepts 3 values:

```
    user_id,                             // string
    inventory_id,                        // integer
    quantity,                            // integer
```

The `user_id` is gotten from the authenticated user while the `inventory_id` is gotten from the url. Thus, the quantity
is the only required value. When an item is added to the cart, the new quantity of that item is updated in the
inventory.

## Testing in Postman

This project is also hosted on heroku and the endpoints can be tested in postman

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/15465737-da43f176-f364-438a-a390-329347ec70dc?action=collection%2Ffork&collection-url=entityId%3D15465737-da43f176-f364-438a-a390-329347ec70dc%26entityType%3Dcollection%26workspaceId%3D1ee86239-a553-49d1-9d86-ca953566ed4f)

[Docs](https://documenter.getpostman.com/view/15465737/UVeGqR4L#d8f8c297-0f5b-4945-bfc7-290b6008a067)
