<?php

namespace Aytacmalkoc\Tracker\Controllers;

use App\Http\Controllers\Controller;
use Aytacmalkoc\Tracker\Tracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Jenssegers\Agent\Agent;
use Aytacmalkoc\Tracker\Models\Tracking;
use stdClass;

/**
 * @author Aytac Malkoc
 * @version 1.0.0
 */
class TrackingController extends Controller
{
    /**
     * @var string
     */
    public string $identifier;

    /**
     * @var Request
     */
    private Request $request;

    private object $data;

    /**
     * @var Agent
     */
    private Agent $agent;

    /**
     * @var Tracker
     */
    private Tracker $tracker;

    /**
     * @var object
     */
    private object $geo;

    /**
     * @var array|false|int|string|null
     */
    public array|false|int|null|string $url;

    /**
     * @var object
     */
    public object $query;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->tracker = new Tracker();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function track(Request $request): JsonResponse
    {
        $this->request = $request;
        $this->data = (object) json_decode(base64_decode($this->request->post('payload')));
        $this->url = parse_url($this->data->landingUrl);
        $this->query = $this->getQueriesFromUrl();

        if ($this->data->identifier && $this->data->identifier !== 'undefined') {
            $this->identifier = $this->data->identifier;
        }else {
            $this->identifier = $this->tracker->createUniqueIdentifier();
        }

        $this->geo = $this->tracker->getGeoInformation($this->request->ip(), $this->identifier);

        $this->saveRecords();

        return response()->json([
            'identifier' => $this->identifier,
            'remain' => RateLimiter::availableIn(config('tracker.rate_limiter.key') . "-{$this->request->ip()}"),
        ]);
    }

    /**
     * @return object
     */
    public function getQueriesFromUrl(): object
    {
        if (isset($this->url['query'])) {
            parse_str($this->url['query'], $query);
        } else {
            $query = new stdClass();
        }

        return (object) $query;
    }

    /**
     * @return void
     */
    public function saveRecords(): void
    {
        try {
            $ip = $this->request->ip();
            $rateLimiterKey = config('tracker.rate_limiter.key') . "-$ip";
            $cacheKey = config('tracker.cache_key') . "-tracking-model-$ip";

            RateLimiter::attempt($rateLimiterKey, config('tracker.rate_limiter.per_minute'), function () use ($ip, $cacheKey) {
                $tracking = Cache::remember($cacheKey, config('tracker.cache_ttl', 5 * 60), function () use ($ip) {
                    return Tracking::where('identifier', $this->data->identifier)->orWhere('ip_address', $ip)->first();
                });

                if (!$tracking) {
                    $data = $this->createDataArray();

                    $createdTracking = Tracking::create([
                        'identifier' => $this->identifier,
                        ...$data
                    ]);

                    $createdTracking->steps()->create($data);
                }else {
                    $tracking->steps()->create($this->createDataArray());
                }
            });
        }catch (\Exception $exception) {
            Log::channel('tracker')->error($exception->getMessage(), [
                'identifier' => $this->identifier,
                'request' => $this->request,
                'agent' => $this->agent,
                'geo' => $this->geo,
                'query' => $this->query,
                'data' => $this->data,
            ]);
        }
    }

    /**
     * @return array
     */
    public function createDataArray(): array
    {
        return [
            'ip_address' => $this->request->ip(),
            'referrer_url' => $this->data->referrer,
            'landing_url' => $this->data->landingUrl,
            'query' => $this->url['query'] ?? null,
            'ad_group' => $this->query->adgroup ?? null,
            'ads_group' => $this->query->adsgroup ?? null,
            'campaign' => $this->query->campaign ?? null,
            'clid' => $this->query->gclid ?? $this->query->fbclid ?? $this->query->li_fat_id ?? null, // google/facebook/linkedin click id
            'continent' => $this->geo->continent ?? null,
            'continent_code' => $this->geo->continentCode ?? null,
            'country' => $this->geo->country ?? null,
            'country_code' => $this->geo->countryCode ?? null,
            'city' => $this->geo->city ?? null,
            'region' => $this->geo->region ?? null,
            'region_name' => $this->geo->regionName ?? null,
            'district' => $this->geo->district ?? null,
            'zip' => $this->geo->zip ?? null,
            'latitude' => $this->geo->lat ?? null,
            'longitude' => $this->geo->lon ?? null,
            'timezone' => $this->geo->timezone ?? null,
            'currency' => $this->geo->currency ?? null,
            'language' => $this->data->current_locale,
            'languages' => $this->request->getLanguages(),
            'user_agent' => $this->request->userAgent(),
            'browser' => $this->data->browser ?? 'Unknown',
            'platform' => $this->agent->platform() ?? 'Unknown',
            'device' => $this->agent->deviceType() ?? 'Unknown',
            'os' => $this->data->os ?? 'Unknown',
            'version' => $this->data->version ?? 'Unknown',
        ];
    }
}
