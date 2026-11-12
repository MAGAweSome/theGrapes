<x-layouts::app :title="__('Site Editor')">
    {{-- Google Fonts for the dropdown preview --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Rye&family=Inter:wght@400;600;700&family=Instrument+Sans:wght@400;600;700&family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&family=Lora:wght@400;700&family=Playfair+Display:wght@400;700&family=Oswald:wght@400;600;700&family=Raleway:wght@400;600;700&display=swap" rel="stylesheet" />

    <div class="flex flex-col flex-1 w-full overflow-hidden">

        {{-- Secondary Toolbar --}}
        <div class="w-full flex items-center gap-4 bg-[#120d0a] border-b border-white/10 px-6 py-2 shadow-sm flex-shrink-0">
            <div class="flex items-center gap-2">
                <button class="p-1.5 text-[#d7c5b3] hover:text-white rounded flex items-center justify-center" title="Undo" onclick="editorUndo()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                </button>
                <button class="p-1.5 text-[#d7c5b3] hover:text-white rounded flex items-center justify-center" title="Redo" onclick="editorRedo()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3" /></svg>
                </button>
            </div>

            <div class="w-px h-5 bg-white/20"></div>

            <div class="flex items-center gap-3">
                <span class="text-xs text-[#d7c5b3] font-medium uppercase tracking-wider">Theme Color:</span>
                <input type="color" id="themeColorPicker" value="#d15f2f" class="w-8 h-8 rounded cursor-pointer bg-transparent border-0 p-0" />
            </div>

            <div class="w-px h-5 bg-white/20"></div>

            <div class="flex items-center gap-3">
                <span class="text-xs text-[#d7c5b3] font-medium uppercase tracking-wider">Font:</span>
                <select id="fontPicker" class="bg-[#1a130f] border border-white/10 rounded-lg px-3 py-1.5 text-sm text-white focus:outline-none focus:border-[#d15f2f] min-w-[180px]">
                    <option class="bg-white text-gray-900" value="Montserrat" style="font-family: Montserrat;">Montserrat</option>
                    <option class="bg-white text-gray-900" value="Inter" style="font-family: Inter;">Inter</option>
                    <option class="bg-white text-gray-900" value="Instrument Sans" style="font-family: 'Instrument Sans';">Instrument Sans</option>
                    <option class="bg-white text-gray-900" value="Poppins" style="font-family: Poppins;">Poppins</option>
                    <option class="bg-white text-gray-900" value="Roboto" style="font-family: Roboto;">Roboto</option>
                    <option class="bg-white text-gray-900" value="Lora" style="font-family: Lora;">Lora</option>
                    <option class="bg-white text-gray-900" value="Playfair Display" style="font-family: 'Playfair Display';">Playfair Display</option>
                    <option class="bg-white text-gray-900" value="Oswald" style="font-family: Oswald;">Oswald</option>
                    <option class="bg-white text-gray-900" value="Raleway" style="font-family: Raleway;">Raleway</option>
                    <option class="bg-white text-gray-900" value="Rye" style="font-family: Rye;">Rye</option>
                    <option class="bg-white text-gray-900" value="Mandingo" style="font-family: Mandingo;">Mandingo</option>
                </select>
            </div>
        </div>

        {{-- Main workspace --}}
        <div class="flex flex-1 overflow-hidden min-h-0">

            {{-- LEFT SIDEBAR: Site Contents --}}
            <div class="w-72 flex-shrink-0 flex flex-col bg-[#0a0705] border-r border-white/10">
                <div class="p-4 border-b border-white/10 bg-white/5 flex-shrink-0">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Site Contents</h2>
                    <p class="text-[10px] text-[#d7c5b3] mt-1">Click any field to edit. Font applies to active field.</p>
                </div>

                {{-- This section scrolls independently --}}
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="sidebar-fields">

                    {{-- Hero Section --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">🎸 Hero Section</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Hero Image</label>
                            <input type="file" id="heroImagePicker" accept="image/*" class="w-full text-xs text-[#d7c5b3] file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#d15f2f] file:text-white hover:file:bg-[#b04f27] cursor-pointer" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Wordmark Top</label>
                            <input type="text" data-target="wordmark_top" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="The" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Wordmark Bottom</label>
                            <input type="text" data-target="wordmark_bottom" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Grapes" />
                        </div>
                    </div>

                    {{-- Hero Copy --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">📝 Hero Copy</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Eyebrow Text</label>
                            <input type="text" data-target="eyebrow" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Live music with a vintage edge" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Headline (h1)</label>
                            <textarea rows="2" data-target="headline" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition resize-none">Big soul, bright hooks, and a set that stays with you.</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Lead Paragraph</label>
                            <textarea rows="3" data-target="lead" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition resize-none">The Grapes bring warm grooves, sharp songwriting, and a room-filling sound built for clubs, festivals, and late nights. Book the band, check the next show, or jump into the latest tracks.</textarea>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">🔗 Action Buttons</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Button 1 Text</label>
                            <input type="text" data-target="btn_shows" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Upcoming Shows" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Button 2 Text</label>
                            <input type="text" data-target="btn_socials" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Socials" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Button 3 Text</label>
                            <input type="text" data-target="btn_booking" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Booking" />
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">📊 Stats Cards</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Stat 1 Label</label>
                            <input type="text" data-target="stat1_label" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Upcoming gigs!" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Stat 2 Label</label>
                            <input type="text" data-target="stat2_label" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Active social and booking links being kept current." />
                        </div>
                    </div>

                    {{-- Aside / Shows Card --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">📋 Next Gigs Card</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Card Title</label>
                            <input type="text" data-target="gigs_title" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Next Gigs" />
                        </div>
                    </div>

                    {{-- Booking Section --}}
                    <div class="border-b border-white/10 pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">📩 Booking Section</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Booking Eyebrow</label>
                            <input type="text" data-target="booking_eyebrow" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Book The Grapes" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Booking Heading (h2)</label>
                            <input type="text" data-target="booking_heading" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Send a booking enquiry" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Booking Description</label>
                            <textarea rows="2" data-target="booking_desc" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition resize-none">Use this form to share your event details and we'll follow up from here.</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Submit Button Text</label>
                            <input type="text" data-target="booking_submit" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Send Enquiry" />
                        </div>
                    </div>

                    {{-- Socials Section --}}
                    <div class="pb-3">
                        <p class="text-[10px] uppercase tracking-widest text-[#f0a56f] font-bold mb-2">🌐 Socials Section</p>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-[#d7c5b3] mb-1">Section Title</label>
                            <input type="text" data-target="socials_title" class="editor-field w-full rounded bg-white/5 border border-white/10 p-2 text-sm text-white focus:border-[#d15f2f] focus:ring-1 focus:ring-[#d15f2f] transition" value="Socials" />
                        </div>
                    </div>

                </div>
            </div>

            {{-- RIGHT: Canvas (iframe preview) --}}
            <div class="flex-1 bg-[#1a130f] flex justify-center p-4 sm:p-6 overflow-hidden min-h-0">
                <div id="editor-wrapper" class="transition-all duration-300 ease-in-out w-full h-full flex flex-col" style="max-width: 100%;">
                    <div class="w-full flex-1 bg-white rounded-xl shadow-2xl overflow-hidden border border-white/20 relative min-h-0">
                        <iframe
                            src="{{ url('/?editor_mode=1') }}"
                            id="live-preview"
                            class="w-full h-full absolute inset-0 border-0"
                            title="Live Site Preview">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Track which field the user last clicked/focused
        let activeFieldTarget = null;

        // Listen for focus on all editor fields
        document.querySelectorAll('.editor-field').forEach(field => {
            field.addEventListener('focus', () => {
                activeFieldTarget = field.dataset.target;
                // Highlight active
                document.querySelectorAll('.editor-field').forEach(f => f.classList.remove('!border-[#f0a56f]'));
                field.classList.add('!border-[#f0a56f]');
            });

            field.addEventListener('input', () => {
                sendToIframe(field.dataset.target, field.value);
            });
        });

        // Theme color picker — sends in real time on every input tick
        document.getElementById('themeColorPicker').addEventListener('input', function() {
            sendToIframe('theme_primary', this.value);
        });

        // Font picker — applies only to the active field's element in the iframe
        document.getElementById('fontPicker').addEventListener('change', function() {
            if (activeFieldTarget) {
                sendToIframe('font_change', JSON.stringify({
                    target: activeFieldTarget,
                    font: this.value
                }));
            }
        });

        function sendToIframe(key, value) {
            const iframe = document.getElementById('live-preview');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage({
                    type: 'editor_update',
                    key: key,
                    value: value
                }, '*');
            }
        }

        document.getElementById('heroImagePicker').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    sendToIframe('hero_image', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Save
        window.addEventListener('editor-save', () => {
            alert('Settings saved! (Database persistence coming soon)');
        });
    </script>
</x-layouts::app>




