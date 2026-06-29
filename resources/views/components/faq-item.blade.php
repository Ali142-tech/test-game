@props(['question', 'answer', 'open' => false])

<details class="faq-item" @if($open) open @endif>
    <summary class="faq-item__question">{{ $question }}</summary>
    <div class="faq-item__answer">{!! nl2br(e($answer)) !!}</div>
</details>
