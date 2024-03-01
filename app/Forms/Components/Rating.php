<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasIcon;

class Rating extends Field
{
    use HasIcon;


    protected string $view = 'forms.components.rating';

    //ratings
    protected int|\Closure $ratings = 5;
    //hoverRating
    protected int|\Closure|null $hoverRating = null;

    //auto submit
    protected bool $autoSubmit = false;

    public function autoSubmit(bool $autoSubmit = true): static
    {
        $this->autoSubmit = $autoSubmit;
        return $this;
    }

    public function getAutoSubmit(): bool
    {
        return $this->autoSubmit;
    }


    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon) ?? 'heroicon-c-star';
    }


    public function hoverRating(int|\Closure|null $hoverRating): static
    {
        $this->hoverRating = $hoverRating;
        return $this;
    }

    public function getHoverRating(): ?int
    {
        return $this->evaluate($this->hoverRating) ?? $this->getState();
    }

    public function ratings(int|\Closure $ratings): static
    {
        $this->ratings = $ratings;

        return $this;
    }

    public function getRatings(): int
    {
        return $this->evaluate($this->ratings);
    }


}
