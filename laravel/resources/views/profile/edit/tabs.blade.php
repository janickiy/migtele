<div class="profile-tabs tabs">
    <a href="{{ url('/profile/edit/individual') }}" class="{{ $selected == 1 ? 'active' : '' }}">Физическое лицо</a>
    <a href="{{ url('/profile/edit/juridical') }}" class="{{ $selected == 2 ? 'active' : '' }}">Юридическое лицо</a>
</div>