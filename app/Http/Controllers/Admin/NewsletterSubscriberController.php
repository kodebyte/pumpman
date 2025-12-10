<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Http\Requests\Admin\NewsletterSubscriber\StoreNewsletterSubscriberRequest;
use App\Http\Requests\Admin\NewsletterSubscriber\UpdateNewsletterSubscriberRequest;
use App\Services\NewsletterSubscriberService;
use Exception;

class NewsletterSubscriberController extends Controller
{
    public function __construct(
        protected NewsletterSubscriberRepositoryInterface $repo,
        protected NewsletterSubscriberService $service
    ) {}

    public function index()
    {
        $params = request()->only(['search', 'is_active']);
        $perPage = request('limit', 10);
        
        $subscribers = $this->repo->getAll($params, $perPage);
        
        // Perhatikan nama folder view: 'newsletter_subscribers'
        return view('admin.pages.subscriber.index', compact('subscribers', 'perPage'));
    }

    public function create()
    {
        return view('admin.pages.subscriber.create');
    }

    public function store(StoreNewsletterSubscriberRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return to_route('admin.newsletter-subscribers.index')->with('success', 'Subscriber added successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to add subscriber.');
        }
    }

    public function edit(string $id)
    {
        $subscriber = $this->repo->findById($id);
        return view('admin.pages.subscriber.edit', compact('subscriber'));
    }

    public function update(UpdateNewsletterSubscriberRequest $request, string $id)
    {
        try {
            $this->service->update($id, $request->validated());
            return to_route('admin.newsletter-subscribers.index')->with('success', 'Subscriber updated successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to update subscriber.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->service->delete($id);
            return to_route('admin.newsletter-subscribers.index')->with('success', 'Subscriber deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete subscriber.');
        }
    }
}