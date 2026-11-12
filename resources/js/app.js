const bookingForm = document.querySelector('[data-booking-form]');

if (bookingForm) {
	const statusContainer = document.querySelector('[data-booking-status]');
	const submitButton = bookingForm.querySelector('[data-booking-submit]');
	const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

	const showStatus = (message, variant = 'success') => {
		if (!statusContainer) {
			return;
		}

		const styles = variant === 'error'
			? 'border-red-400/20 bg-red-500/10 text-red-100'
			: variant === 'pending'
				? 'border-[#f0a56f]/20 bg-[#f0a56f]/10 text-[#ffcf9e]'
				: 'border-emerald-400/20 bg-emerald-500/10 text-emerald-100';

		statusContainer.replaceChildren();

		const messageBox = document.createElement('div');
		messageBox.className = `rounded-2xl border px-4 py-3 text-sm ${styles}`;
		messageBox.textContent = message;

		statusContainer.append(messageBox);
	};

	bookingForm.addEventListener('submit', async (event) => {
		event.preventDefault();

		const scrollPosition = window.scrollY;
		const scrollLeft = window.scrollX;

		if (submitButton) {
			submitButton.disabled = true;
			submitButton.dataset.originalLabel = submitButton.textContent ?? 'Send Enquiry';
			submitButton.textContent = 'Sending...';
		}

		showStatus('Sending your enquiry...', 'pending');

		try {
			const response = await fetch(bookingForm.action, {
				method: 'POST',
				headers: {
					'Accept': 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
					'X-CSRF-TOKEN': csrfToken,
				},
				body: new FormData(bookingForm),
			});

			const data = await response.json().catch(() => ({}));

			if (!response.ok) {
				const message = data?.message
					|| Object.values(data?.errors || {}).flat()?.[0]
					|| 'Please check the form and try again.';

				showStatus(message, 'error');
				return;
			}

			bookingForm.reset();
			showStatus(data?.message || 'Thanks. Your enquiry has been sent.');
		} catch (error) {
			showStatus('We could not send your enquiry right now. Please try again.', 'error');
		} finally {
			if (submitButton) {
				submitButton.disabled = false;
				submitButton.textContent = submitButton.dataset.originalLabel || 'Send Enquiry';
			}

			window.requestAnimationFrame(() => {
				window.scrollTo({
					top: scrollPosition,
					left: scrollLeft,
					behavior: 'auto',
				});
			});
		}
	});
}
