<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $timezone = config('store.timezone', config('app.timezone'));
        $hours = config('store.hours', []);
        $now = Carbon::now($timezone);
        $todayKey = strtolower($now->format('l'));

        $dayLabels = [
            'monday' => __('Senin'),
            'tuesday' => __('Selasa'),
            'wednesday' => __('Rabu'),
            'thursday' => __('Kamis'),
            'friday' => __('Jumat'),
            'saturday' => __('Sabtu'),
            'sunday' => __('Minggu'),
        ];
        $weekdays = array_keys($dayLabels);

        $todaySchedule = $hours[$todayKey] ?? ['open' => null, 'close' => null];

        $storeStatus = [
            'is_open' => false,
            'label' => __('Tutup'),
            'message' => __('Hari ini tutup'),
            'color' => 'rose',
        ];

        if (! empty($todaySchedule['open']) && ! empty($todaySchedule['close'])) {
            $openAt = Carbon::createFromFormat('Y-m-d H:i', sprintf('%s %s', $now->format('Y-m-d'), $todaySchedule['open']), $timezone);
            $closeAt = Carbon::createFromFormat('Y-m-d H:i', sprintf('%s %s', $now->format('Y-m-d'), $todaySchedule['close']), $timezone);

            if ($now->greaterThanOrEqualTo($openAt) && $now->lessThan($closeAt)) {
                $storeStatus = [
                    'is_open' => true,
                    'label' => __('Buka'),
                    'message' => __('Buka sampai :time', ['time' => $closeAt->format('H:i')]),
                    'color' => 'emerald',
                ];
            } elseif ($now->lessThan($openAt)) {
                $storeStatus['message'] = __('Buka mulai jam :time', ['time' => $openAt->format('H:i')]);
            } else {
                $nextOpen = null;
                $todayIndex = array_search($todayKey, $weekdays, true);
                if ($todayIndex === false) {
                    $todayIndex = 0;
                }

                for ($offset = 1; $offset <= 7; $offset++) {
                    $candidate = $weekdays[($todayIndex + $offset) % 7];
                    $candidateSchedule = $hours[$candidate] ?? ['open' => null, 'close' => null];

                    if (! empty($candidateSchedule['open'])) {
                        $nextOpen = [
                            'day' => $candidate,
                            'time' => $candidateSchedule['open'],
                        ];
                        break;
                    }
                }

                if ($nextOpen) {
                    $storeStatus['message'] = __('Tutup. Buka kembali :day jam :time', [
                        'day' => $dayLabels[$nextOpen['day']] ?? ucfirst($nextOpen['day']),
                        'time' => $nextOpen['time'],
                    ]);
                } else {
                    $storeStatus['message'] = __('Tutup untuk sementara waktu');
                }
            }
        }

        $operatingHours = [];
        foreach ($weekdays as $day) {
            $schedule = $hours[$day] ?? ['open' => null, 'close' => null];

            $operatingHours[] = [
                'key' => $day,
                'label' => $dayLabels[$day] ?? ucfirst($day),
                'open' => $schedule['open'],
                'close' => $schedule['close'],
                'is_today' => $day === $todayKey,
            ];
        }

        return view('contact', [
            'operatingHours' => $operatingHours,
            'storeStatus' => $storeStatus,
        ]);
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $recipient = config('mail.contact_recipient') ?: config('mail.from.address');

        $subject = __('[Jurangan 99] :subject', ['subject' => $data['subject']]);

        $parts = [
            __('Nama') . ': ' . $data['name'],
            __('Email') . ': ' . $data['email'],
        ];

        if (! empty($data['phone'])) {
            $parts[] = __('Telepon') . ': ' . $data['phone'];
        }

        $parts[] = '---';
        $parts[] = __('Pesan') . ':';
        $parts[] = $data['message'];

        $body = implode("\n", $parts);

        $mailto = 'mailto:' . rawurlencode($recipient)
            . '?subject=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);

        return redirect()->away($mailto);
    }
}
