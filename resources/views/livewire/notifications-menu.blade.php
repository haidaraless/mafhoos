<div wire:poll.45s class="relative">
    <flux:dropdown position="top" align="end">
        <flux:button variant="ghost" class="relative h-10 w-10 flex items-center justify-center">
            <div class="w-10">
                @svg('phosphor-bell', 'size-6')
            </div>

            @if ($this->unreadCount > 0)
                <span class="absolute -top-1 -right-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1 text-xs font-semibold text-white">
                    {{ $this->unreadCount }}
                </span>
            @endif
        </flux:button>

        <flux:menu class="w-80 max-w-xs">
            <div class="flex items-center justify-between px-4 py-3">
                <span class="text-sm font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-300">
                    Notifications
                </span>
                @if ($this->unreadCount > 0)
                    <button
                        wire:click="markAllAsRead"
                        type="button"
                        class="text-xs font-medium uppercase tracking-wide text-orange-500 hover:text-orange-400 transition-colors"
                    >
                        Mark all as read
                    </button>
                @endif
            </div>

            <flux:menu.separator />

            @forelse ($this->notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $title = $notification->data['title'] ?? 'Notification';
                    $body = $notification->data['body'] ?? null;
                    $timestamp = optional($notification->created_at)?->diffForHumans();
                @endphp

                <flux:menu.item
                    wire:key="notification-{{ $notification->id }}"
                    wire:click.prevent="openNotification('{{ $notification->id }}')"
                    class="w-full"
                >
                    <div class="flex items-start gap-3 w-full">
                        @if (!empty($notification->data['icon']))
                            <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 text-neutral-600 dark:bg-white/5 dark:text-neutral-200">
                                @svg($notification->data['icon'], 'size-4')
                            </span>
                        @endif

                        <div class="flex flex-col gap-1 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <span class="text-sm font-medium {{ $isUnread ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-300' }}">
                                    {{ $title }}
                                </span>
                                @if ($isUnread)
                                    <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                @endif
                            </div>

                            @if ($body)
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                    {{ $body }}
                                </p>
                            @endif

                            @if ($timestamp)
                                <span class="text-[11px] uppercase tracking-wide text-neutral-400">
                                    {{ $timestamp }}
                                </span>
                            @endif
                        </div>
                    </div>
                </flux:menu.item>
            @empty
                <div class="px-4 py-10 text-center text-sm text-neutral-500 dark:text-neutral-400">
                    You're all caught up!
                </div>
            @endforelse
        </flux:menu>
    </flux:dropdown>
</div>

