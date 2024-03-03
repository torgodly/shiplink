import React, {useEffect} from "react";

const ScrollToTop = (props) => {
    useEffect(() => {
        window.scrollTo({top: 0, left: 0, behavior: 'smooth'});
    }, []);

    return <>
        {props.children}
    </>
};

export default ScrollToTop;
