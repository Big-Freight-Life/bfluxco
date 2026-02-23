# Case Studies Carousel Specification

> **DO NOT CHANGE** - This carousel behavior has been carefully tuned.

## Card Centering on Load

The second card is automatically centered on screen when the page loads. This is the correct behavior.

**Location:** `assets/js/main.js` in `initCaseCarousel()`

```javascript
// Center the second card on load
var cards = carousel.querySelectorAll('.case-card');
if (cards.length >= 2) {
    var secondCard = cards[1];
    // Get the second card's position relative to the carousel
    var cardRect = secondCard.getBoundingClientRect();
    var carouselRect = carousel.getBoundingClientRect();
    var cardCenter = secondCard.offsetLeft + (secondCard.offsetWidth / 2);
    var viewportCenter = carousel.offsetWidth / 2;
    var scrollToCenter = cardCenter - viewportCenter;
    carousel.scrollLeft = Math.max(0, scrollToCenter);
}
```

## Key Card Specifications

| Property | Value |
|----------|-------|
| Card width (desktop) | 90vw |
| Card width (tablet) | 70vw |
| Card padding | 50px |
| Content max-width | 500px |
| Featured image width | 70% (centered) |
| Featured image ratio | 16:9 |
| Gap between cards | 24px |
| Border radius | 24px |

## Carousel Features

- Mouse drag-to-scroll enabled
- Arrow button navigation
- Keyboard navigation (left/right arrows when focused)
- Second card centered on initial load

## Related Files

- `front-page.php` - Carousel HTML structure
- `style.css` - Card and carousel styles (search for `.case-card`)
- `assets/js/main.js` - `initCaseCarousel()` function
