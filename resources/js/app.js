import './bootstrap';


const willLeftLessThan40pxToScrollEnd = (nextStep) => {
    const scrollLeftAfterTwoClicks = carousel.scrollLeft + (nextStep*2)
    return scrollLeftAfterTwoClicks > carousel.scrollWidth - 40
}

const willLeftLessThan40pxToScrollStart = (nextStep) => {
    const scrollLeftAfterOneClick = carousel.scrollLeft - nextStep
    return scrollLeftAfterOneClick < 40
}

const handleClickGoAhead = () => {
    let nextStep = carousel.offsetWidth
    if(willLeftLessThan40pxToScrollEnd(nextStep)) nextStep *= 2

    carousel.scroll({
      left: carousel.scrollLeft + nextStep,
      behavior: "smooth"
    })
}

const handleClickGoBack = () => {
    let nextStep = carousel.offsetWidth
    if(willLeftLessThan40pxToScrollStart(nextStep)) nextStep *= 2
    
    carousel.scroll({
      left: carousel.scrollLeft - nextStep,
      behavior: "smooth"
    })
}
