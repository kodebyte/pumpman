<span x-data="{ 
        encoded: '{{ $encryptedEmail }}',
        decoded: '' 
      }" 
      x-init="decoded = atob(encoded)"
      class="inline-block">
    
    <a :href="'mailto:' + decoded"  x-text="decoded"class="{{ $classes }}">
       <span class="hidden">Email Protected</span>
    </a>
</span>