<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteEditorController extends Controller
{
    public function index()
    {
        return view('dashboard.site-editor');
    }

    public function load()
    {
        $html = SiteSetting::valueFor('home_html', '');
        
        if (empty($html)) {
            // Load the original Blade view content as the starting point.
            // We use a dummy request to render the view without customHtml.
            config(['app.editor_mode' => true]);
            $html = view('welcome', [
                'upcomingShows' => \App\Models\Show::where('is_published', true)->orderBy('event_date', 'asc')->get(),
                'socialLinks' => \App\Models\SocialLink::where('is_active', true)->orderBy('sort_order', 'asc')->get()
            ])->render();
            // We just need the body content, but GrapesJS can parse the full HTML document and extract styles/body automatically.
        }

        return response()->json([
            'gjs-components' => json_decode(SiteSetting::valueFor('home_components', '[]')),
            'gjs-styles' => json_decode(SiteSetting::valueFor('home_styles', '[]')),
            'gjs-html' => $html,
            'gjs-css' => SiteSetting::valueFor('home_css', ''),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        
        if (isset($data['gjs-components'])) {
            SiteSetting::updateOrCreate(['key' => 'home_components'], ['value' => json_encode($data['gjs-components'])]);
        }
        if (isset($data['gjs-styles'])) {
            SiteSetting::updateOrCreate(['key' => 'home_styles'], ['value' => json_encode($data['gjs-styles'])]);
        }
        if (isset($data['gjs-html'])) {
            SiteSetting::updateOrCreate(['key' => 'home_html'], ['value' => $data['gjs-html']]);
        }
        if (isset($data['gjs-css'])) {
            SiteSetting::updateOrCreate(['key' => 'home_css'], ['value' => $data['gjs-css']]);
        }
        
        return response()->json(['message' => 'Saved']);
    }
}
