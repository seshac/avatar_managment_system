## Avatar Managment System

### Step 1: Clone the repo - https://github.com/seshac/avatar_managment_system.git

### Step 2: Local Setup

A. Run ```Composer install```

B. Update the database details in .env

C. Run ```php artisan migrate```

D. Run ```php artisan db:seed``` to setup some sample data.

### Step 3: For Endpoints please follow the below postman collection

 [Postman collection](./api.postman_collection.json)

### Step 4:

For temporary demo purposes, I have hosted the following server.

http://3.7.66.99

More information about the endpoints.

1. To Get the list of items by categories

    Get request: http://3.7.66.99/api/items
    
2. Buy a new item for the user

     Put request: ```http://3.7.66.99/api/user/{userId}/item/{ItemId}/buy```
     
      Example : http://3.7.66.99/user/1/item/1/buy
      
3. Activate the current list of items for the user
 
    Post request: ```http://3.7.66.99/api/user/{userId}/items/activate```
    
    Example: http://3.7.66.99/api/user/1/items/activate
    
    Input json (Items)
    
    ```json
        {

            "items": [1,3,4] //item Id's

        }
     ```

4. Get the current Avatar list for the user
 
      Get Request : ```http://3.7.66.99/api/user/{userId}/items```

      Example : http://3.7.66.99/api/user/1/items
    
