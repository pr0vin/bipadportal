@props(['link'])
<a class="card bg-white p-3 rounded my-3" href="{{ $link ?? '#' }}">
    <h1 class="mr-4 kalimati-font">{{ $count ?? null }}</h1>
   <span>{{ $title ?? null }}</span>
</a>
