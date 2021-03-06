<?php

namespace IonescuAlex\GoogleDistanceMatrix;

use GuzzleHttp\Client;
use IonescuAlex\GoogleDistanceMatrix\Response\GoogleDistanceMatrixResponse;

class GoogleDistanceMatrix
{

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var array
     */
    private $origins;

    /**
     * @var array
     */
    private $destinations;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $units;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $avoid;

    /**
    * @var int
    */
    private $arrival_time;

    /**
     * @var int
     */
    private $departure_time;

    /**
     * @var string
     */
    private $traffic_model;

    /**
     * @var array
     */
    private $transit_modes;

    /**
     * @var string
     */
    private $transit_routing_preference;

    /**
     * URL for API
     */
    const URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    const MODE_DRIVING = 'driving';
    const MODE_WALKING = 'walking';
    const MODE_BICYCLING = 'bicycling';
    const MODE_TRANSIT = 'transit';

    const UNITS_METRIC = 'metric';
    const UNITS_IMPERIAL = 'imperial';

    const AVOID_TOLLS = 'tolls';
    const AVOID_HIGHWAYS = 'highways';
    const AVOID_FERRIES = 'ferries';
    const AVOID_INDOOR = 'indoor';

    const TRAFFIC_MODE_BEST_GUESS = 'best_guess';
    const TRAFFIC_MODE_PESSIMISTIC = 'pessimistic';
    const TRAFFIC_MODE_OPTIMISTIC = 'optimistic';

    const TRANSIT_MODE_BUS = 'bus';
    const TRANSIT_MODE_SUBWAY = 'subway';
    const TRANSIT_MODE_TRAIN = 'train';
    const TRANSIT_MODE_TRAM = 'tram';
    const TRANSIT_MODE_RAIL = 'rail';

    const ROUTING_LESS_WALKING = 'less_walking';
    const ROUTING_FEWER_TRANSFERS = 'fewer_transfers';

    /**
     * GoogleDistanceMatrix constructor.
     *
     * @param $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey() : string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getTransitRoutingPreference(): string
    {
        return $this->transit_routing_preference;
    }

    /**
     * @param string $transit_routing_preference
     * @return GoogleDistanceMatrix
     */
    public function setTransitRoutingPreference(string $transit_routing_preference) : GoogleDistanceMatrix
    {
        $this->transit_routing_preference = $transit_routing_preference;
        return $this;
    }

    /**
     * @return array
     */
    public function getTransitModes() : array
    {
        return $this->transit_modes;
    }

    /**
     * @param array $transit_modes
     * @return GoogleDistanceMatrix
     */
    public function setTransitModes($transit_modes) : GoogleDistanceMatrix
    {
        $this->transit_modes = array($transit_modes);
        return $this;
    }

    /**
     * @param $transit_mode
     * @return GoogleDistanceMatrix
     */
    public function addTransitMode($transit_mode) : GoogleDistanceMatrix
    {
        $this->transit_modes[] = $transit_mode;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrafficModel() : string
    {
        return $this->traffic_model;
    }

    /**
     * @param string $traffic_model
     * @return GoogleDistanceMatrix
     */
    public function setTrafficModel(string $traffic_model = self::TRAFFIC_MODE_BEST_GUESS) : GoogleDistanceMatrix
    {
        $this->traffic_model = $traffic_model;
        return $this;
    }

    /**
     * @return int
     */
    public function getDepartureTime() : int
    {
        return $this->departure_time;
    }

    /**
     * @param int $departure_time
     * @return GoogleDistanceMatrix
     */
    public function setDepartureTime(int $departure_time) : GoogleDistanceMatrix
    {
        $this->departure_time = $departure_time;
        return $this;
    }

    /**
     * @return int
     */
    public function getArrivalTime() : int
    {
        return $this->arrival_time;
    }

    /**
     * @param int $arrival_time
     * @return GoogleDistanceMatrix
     */
    public function setArrivalTime(int $arrival_time) : GoogleDistanceMatrix
    {
        $this->arrival_time = $arrival_time;
        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage($language = 'en-US') : GoogleDistanceMatrix
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @param string $units
     * @return $this
     */
    public function setUnits($units = self::UNITS_METRIC) : GoogleDistanceMatrix
    {
        $this->units = $units;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnits() : string
    {
        return $this->units;
    }

    /**
     * @param string $origin (for more values use addOrigin method instead)
     * @return $this
     */
    public function setOrigin($origin) : GoogleDistanceMatrix
    {
        $this->origins = array($origin);
        return $this;
    }

    /**
     * @param string $origin
     * @return $this
     */
    public function addOrigin($origin) : GoogleDistanceMatrix
    {
        $this->origins[] = $origin;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrigins() : array
    {
        return $this->origins;
    }

    /**
     * @param string $destination (for more values use addDestination method instead)
     * @return $this
     */
    public function setDestination($destination) : GoogleDistanceMatrix
    {
        $this->destination = array($destination);
        return $this;
    }

    /**
     * @param string $destination
     * @return $this
     */
    public function addDestination($destination) : GoogleDistanceMatrix
    {
        $this->destinations[] = $destination;
        return $this;
    }

    /**
     * @return array
     */
    public function getDestinations() : array
    {
        return $this->destinations;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function setMode($mode = self::MODE_DRIVING) : GoogleDistanceMatrix
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode() : string
    {
        return $this->mode;
    }

    /**
     * @param string $avoid (for more values use | as separator)
     * @return $this
     */
    public function setAvoid($avoid) : GoogleDistanceMatrix
    {
        $this->avoid = $avoid;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvoid() : string
    {
        return $this->avoid;
    }

    /**
     * @return GoogleDistanceMatrixResponse
     * @throws \Exception
     */
    public function sendRequest() : GoogleDistanceMatrixResponse
    {
        $this->validateRequest();
        $data = [
            'key' => $this->apiKey,
            'language' => $this->language,
            'origins' => count($this->origins) > 1 ? implode('|', $this->origins) : $this->origins[0],
            'destinations' => count($this->destinations) > 1 ? implode('|', $this->destinations) : $this->destinations[0],
            'mode' => $this->mode,
            'avoid' => $this->avoid,
            'units' => $this->units,
            'arrival_time' => $this->arrival_time,
            'departure_time' => $this->departure_time,
            'traffic_model' => $this->traffic_model,
            'transit_mode' => count($this->transit_modes) > 1 ? implode('|', $this->transit_modes) : $this->transit_modes[0],
            'transit_routing_preference' => $this->transit_routing_preference
        ];
        $parameters = http_build_query($data);
        $url = self::URL.'?'.$parameters;
        
        return $this->request('GET', $url);
    }

    /**
     * @param string $type
     * @param string $url
     * @return GoogleDistanceMatrixResponse
     * @throws \Exception
     */
    private function request($type = 'GET', $url) : GoogleDistanceMatrixResponse
    {
        $client = new Client();
        $response = $client->request($type, $url);

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Response with status code '.$response->getStatusCode());
        }

        $responseObject = new GoogleDistanceMatrixResponse(json_decode($response->getBody()->getContents()));

        $this->validateResponse($responseObject);

        return $responseObject;
    }

    private function validateResponse(GoogleDistanceMatrixResponse $response) : void
    {

        switch ($response->getStatus()) {
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_OK:
                break;
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_INVALID_REQUEST:
                throw new Exception\ResponseException("Invalid request.", 1);
                break;
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_MAX_ELEMENTS_EXCEEDED:
                throw new Exception\ResponseException("The product of the origin and destination exceeds the limit per request.", 2);
                break;
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_OVER_QUERY_LIMIT:
                throw new Exception\ResponseException("The service has received too many requests from your application in the allowed time range.", 3);
                break;
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_REQUEST_DENIED:
                throw new Exception\ResponseException("The service denied the use of the Distance Matrix API service by your application.", 4);
                break;
            case GoogleDistanceMatrixResponse::RESPONSE_STATUS_UNKNOWN_ERROR:
                throw new Exception\ResponseException("Unknown error.", 5);
                break;
            default:
                throw new Exception\ResponseException(sprintf("Unknown status code: %s",$response->getStatus()), 6);
                break;
        }
    }

    private function validateRequest() : void
    {
        if (empty($this->getOrigins())) {
            throw new Exception\OriginException('Origin must be set.');
        }
        if (empty($this->getDestinations())) {
            throw new Exception\DestinationException('Destination must be set.');
        }
        if (isset($this->departure_time) && isset($this->arrival_time)) {
            throw new Exception\Exception('departure_time and arrival_time cannot be both specified at the same time.');
        }
        if(isset($this->transit_modes) && strcmp($this->mode, self::MODE_TRANSIT) != 0) {
            throw new Exception\Exception('You cannot specify a transit_mode without the current mode ' . $this->mode);
        }
        if (isset($this->transit_routing_preference) && strcmp($this->mode, self::MODE_TRANSIT) != 0) {
            throw new Exception\Exception('This parameter may only be specified for requests where the mode is transit');
        }
    }
}
