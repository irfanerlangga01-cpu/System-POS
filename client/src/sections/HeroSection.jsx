import React, { useRef, useEffect } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import { motion } from 'framer-motion';

const slides = [
  {
    id: 1,
    bgImage: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&w=1600&q=80',
    subtitle: 'IT Business Consulting',
    title: 'Best IT Solutions\nProvider Agency',
    description: 'We provide comprehensive IT solutions that drive business growth and innovation. Our expert team delivers cutting-edge technology services tailored to your specific needs.',
  },
  {
    id: 2,
    bgImage: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&w=1600&q=80',
    subtitle: 'Digital Transformation',
    title: 'Innovative Technology\nPartner',
    description: 'Partner with us to leverage the latest technologies and stay ahead in the competitive market. We specialize in digital transformation.',
  },
  {
    id: 3,
    bgImage: 'https://images.unsplash.com/photo-1552664730-d307ca884978?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&w=1600&q=80',
    subtitle: 'Expert Consulting',
    title: 'Expert IT Consulting\nServices',
    description: 'From strategy to implementation, our consultants guide you through every step of your IT journey. We ensure seamless integration.',
  },
];

const HeroSection = () => {
  const prevRef = useRef(null);
  const nextRef = useRef(null);

  return (
<section className="relative overflow-hidden bg-gradient-to-br from-light-blue to-white">
       <div className="absolute inset-0 bg-gradient-to-br from-primary/10 via-primary/3 to-white z-10" />
      <Swiper
        modules={[Navigation, Pagination, Autoplay, EffectFade]}
        navigation={{ prevEl: prevRef.current, nextEl: nextRef.current }}
        pagination={{ clickable: true, el: '.hero-pagination' }}
        autoplay={{ delay: 6000, disableOnInteraction: false }}
        effect="fade"
        fadeEffect={{ crossFade: true }}
        loop
        className="h-[85vh] min-h-[600px]"
        onBeforeInit={(swiper) => {
          swiper.params.navigation.prevEl = prevRef.current;
          swiper.params.navigation.nextEl = nextRef.current;
        }}
      >
        {slides.map((slide) => (
          <SwiperSlide key={slide.id}>
            <div className="absolute inset-0">
              <img src={slide.bgImage} alt="" className="w-full h-full object-cover opacity-40" />
            </div>
            <div className="relative z-20 container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
              <motion.div
                initial={{ opacity: 0, x: -60 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ duration: 1, delay: 0.3 }}
                className="max-w-2xl"
              >
<span className="inline-block text-primary font-semibold text-sm tracking-[0.2em] mb-4 bg-primary/10 px-4 py-1.5 rounded-full">
                   {slide.subtitle}
                 </span>
                 <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-dark-navy leading-[1.1] mb-6">
                   {slide.title.split('\n').map((line, i) => (
                     <React.Fragment key={i}>
                       {line}
                       {i < slide.title.split('\n').length - 1 && <br />}
                     </React.Fragment>
                   ))}
                 </h1>
                 <p className="text-dark-navy/70 text-base sm:text-lg mb-8 max-w-lg leading-relaxed">
                   {slide.description}
                 </p>
                 <button className="bg-primary text-white px-8 py-4 rounded-full font-semibold text-sm hover:bg-primary-dark shadow-lg hover:shadow-primary/30 transition-all duration-300 hover:translate-y-[-2px]">
                  Our Services
                </button>
              </motion.div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>

      {/* Custom arrows */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-3">
<button
           ref={prevRef}
           className="w-10 h-10 rounded-full bg-primary/10 backdrop-blur-sm flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all duration-300 border border-primary/20"
         >
           <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
           </svg>
         </button>
         <div className="hero-pagination flex items-center gap-2"></div>
         <button
           ref={nextRef}
           className="w-10 h-10 rounded-full bg-primary/10 backdrop-blur-sm flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all duration-300 border border-primary/20"
         >
          <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </section>
  );
};

export default HeroSection;