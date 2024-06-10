# Technical Interview Challenge 1

## Installation

1. Install docker compose https://docs.docker.com/compose/install/#scenario-one-install-docker-desktop
2. Clone the repository
2. Run `docker-compose up`
4. Run `docker-compose exec my-app composer install -o`
3. Run `docker-compose exec my-app php artisan migrate`
5. Run `docker-compose exec my-app php artisan db:seed`
6. Load in browser http://localhost:8081

## Main Changes

1. I have designed this with a modular code structure, so that the code is more maintainable and scalable. Main code namespace is in [/modules](https://github.com/inonbaguio/roofr-parking-design/tree/master/src/myapp/modules) folder
2. The root of the implementation is in the [ParkingController](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Http/Controllers/ParkingController.php)
3. I used [laravel-data](https://spatie.be/docs/laravel-data/v4/validation/introduction) as the main DTO for the data transfer between the controller and the service layer.
4. [ReserveParkingLot](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Actions/ReserveParkingLot.php) contains the main business logic for reserving a parking lot.
5. There is a simple implementation of [Event/Listeners](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Booking/src/BookingEventServiceProvider.php) as well to abstract the logic of sending an email to the user, updating the stastuses of the parking and booking
6. TestCases are located in the [ParkingControllerTest](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/tests/Api/ParkingControllerTest.php)
7. There are some factories as well located in [ParkingLotFactory](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/database/factories/ParkingLotFactory.php), [BookingFactory](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Booking/database/factories/BookingFactory.php)
8. I have made some changes in the [fastcgi_cache](https://github.com/inonbaguio/roofr-parking-design/blob/master/nginx/conf.d/app.conf#L40), due to some caching issues that I encountered during development. (i.e.: whole API responses is being cached by the containers and had to restart for code changes to take effect)
9. There is a logic located in the [AdjacentParkingLotCalculatorService](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Service/AdjacentParkingSlotCalculatorService.php) to compute if the inquried parking slot can accommodate the type of vehicle
10. Created some custom Laravel Custom [Rules](https://github.com/inonbaguio/roofr-parking-design/tree/master/src/myapp/modules/Parking/src/Http/Rules).
   - [FutureTimeRule](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Http/Rules/FutureTimeRule.php)
   - [MinimumParkingTimeInterval](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Http/Rules/MinimumParkingTimeInterval.php)
   - [ValidVehicleType](https://github.com/inonbaguio/roofr-parking-design/blob/master/src/myapp/modules/Parking/src/Http/Rules/ValidVehicleType.php)

## Sample API Requests:

**IMPORTANT:** Ensure that we have ran the db seeders

### /GET/api/parking-lots

```
curl --location 'http://localhost:8081/api/parking-lot/'
```

### /POST/api/parking-lot/reserve/
#### Get the parkingLotId from the /GET/api/parking-lots

```
curl --location 'http://localhost:8081/api/parking-lot/reserve/' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
    "vehicleType": "car",
    "startTime": "2024-06-20 12:35:38",
    "endTime": "2024-06-20 14:35:38",
    "parkingLotId": 30
}'
```

## Assumptions
1. The user is already authenticated and the user_id is passed in the request. I have not included an authentication layer on this project, I guess the highlight of this project should be the actual reservation of the parkign system
2. Assumed that each parking should always be in the future and a minimum of 30minutes interval
3. Parking Lot is charged per hour basis


## Future Improvements
1. Add a proper authentication layer. JWT authentication
2. Scheduled jobs for expiring the parking reservations
3. Payments for the parking reservation
4. Logic improvements for the parking slot reservation
5. OpenAPI Json Schema Documentation, API Versioning
