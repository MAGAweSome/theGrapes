@if (session('status'))
    <div class="field full">
        <div class="rounded-2xl border border-green-400/20 bg-green-500/10 px-4 py-3 text-sm text-green-100">
            {{ session('status') }}
        </div>
    </div>
@endif

@if ($errors->has('booking'))
    <div class="field full">
        <div class="rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
            {{ $errors->first('booking') }}
        </div>
    </div>
@endif

<div class="field full" data-booking-status aria-live="polite" aria-atomic="true"></div>

<form class="booking-form" method="POST" action="{{ route('booking-enquiry.send') }}#booking" data-booking-form novalidate>
    @csrf
    <div class="field">
        <label for="book-name">Your name</label>
        <input id="book-name" type="text" name="name" value="{{ old('name') }}" placeholder="Jon Doe" required />
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="field">
        <label for="book-email">Email address</label>
        <input id="book-email" type="email" name="email" value="{{ old('email') }}" placeholder="jon@example.com" required />
        @error('email')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="field">
        <label for="book-date">Event date</label>
        <input id="book-date" type="date" name="event_date" value="{{ old('event_date') }}" required />
        @error('event_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="field">
        <label for="book-venue">Venue / Location</label>
        <input id="book-venue" type="text" name="venue" value="{{ old('venue') }}" placeholder="The Grapes Pub" required />
        @error('venue')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="field full">
        <label for="book-details">Details</label>
        <textarea id="book-details" name="details" rows="4" placeholder="Tell us about the event..." required>{{ old('details') }}</textarea>
        @error('details')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="field full">
        <button class="button primary" type="submit" data-booking-submit>
            Send Enquiry
        </button>
    </div>
</form>
