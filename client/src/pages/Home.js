import { Avatar, Container, Grid, Skeleton } from "@mui/material";
import MenuCard from "../components/MenuCard";
import { useEffect, useState } from 'react';
import '../styles/HomePage.css'
import useFetch from '../methods/useFetch';
import Carousel from 'react-multi-carousel';
import 'react-multi-carousel/lib/styles.css';
import '../styles/HomePage.css';
import { grey } from "@mui/material/colors";
import Stack from '@mui/material/Stack';
const routes = require('../routes/Routes');
const img = process.env.PUBLIC_URL + '/assets/images/';

const responsive = {
    desktop: {
        breakpoint: { max: 3000, min: 1024 },
        items: 5,
        slidesToSlide: 3 // optional, default to 1.
    },
    tablet: {
        breakpoint: { max: 1024, min: 464 },
        items: 3,
        slidesToSlide: 2 // optional, default to 1.
    },
    mobile: {
        breakpoint: { max: 464, min: 0 },
        items: 3,
        slidesToSlide: 1 // optional, default to 1.
    }
};


export default function Home() {
    const nodeServerHost = routes.NodeServerHost();
    const menuUrl = routes.MenuRoute();
    const [user, setUser] = useState();
    const { data: consommations, isPending, error } = useFetch(nodeServerHost + menuUrl);
    //-----------------------------------------------


    useEffect(() => {
        fetch(nodeServerHost, {
            method: 'GET'
        })
            .then(res => { return res.json() })
            .then(data => setUser(data.indicator));
    }, [menuUrl, nodeServerHost]);

    if (user) {
        if (!isPending && !error) {
            return (
                <Container>
                    <Grid sx={{ marginLeft: 6 }} container spacing={3}>
                        {consommations && consommations.map(consommation => (
                            <Grid sx={{ marginBottom: 6 }} key={consommation.numCons} xs={12} md={6} lg={4}>
                                <MenuCard data={consommation} />
                            </Grid>
                        ))}
                    </Grid>
                </Container>
            );
        }
        else if (error || isPending) {
            return (
                <Skeleton
                    sx={{ bgcolor: 'grey.900', width: '100%', height: '100%', position: 'relative', bottom: '20%', zIndex: -1 }}
                    variant="rectangular"
                />
            );
        }

    } else {
        return (
            <div>
                <div className='homepage'>
                    <p className='main-title' >
                        BIENVENUE DANS NOTRE RESTAURANT
                    </p>
                </div>

                {!isPending && <div style={{ position: 'relative', top: 350 }}>
                    <Carousel
                        arrows={false}
                        swipeable={false}
                        draggable={false}
                        showDots={false}
                        responsive={responsive}
                        ssr={true} // means to render carousel on server-side.
                        infinite={true}
                        autoPlay={true}
                        autoPlaySpeed={1000}
                        keyBoardControl={true}
                        customTransition="transform 1s ease-in-out"
                        transitionDuration={500}
                        containerClass="carousel-container"
                        centerMode={false}
                        removeArrowOnDeviceType={["tablet", "mobile"]}
                        // deviceType={this.props.deviceType}
                        dotListClass="custom-dot-list-style"
                        itemClass="carousel-item-padding-40-px"
                    >
                        {
                            consommations.map((item, i) => <Item key={i} item={item} />)
                        }
                    </Carousel>
                </div>
                }

            </div>
        );
    }

}

function Item(props) {
    return (
        <div>
            <Avatar
                sx={{
                    width: 100,
                    height: 100,
                    marginLeft: '32%',
                    marginBottom: 3
                }}
                src={img + props.item.photo} />
            <p className="under-avatar">{props.item.nom}</p>
        </div>
    )
}