import React from 'react';
import Navbar from './components/Navbar';
import HeroSection from './sections/HeroSection';
import ServicesSection from './sections/ServicesSection';
import VideoBusinessSection from './sections/VideoBusinessSection';
import FeaturedServicesGrid from './sections/FeaturedServicesGrid';
import FeaturesSection from './sections/FeaturesSection';
import WhyChooseUs from './sections/WhyChooseUs';
import CaseStudies from './sections/CaseStudies';
import TeamSection from './sections/TeamSection';
import ConsultationSection from './sections/ConsultationSection';
import StatisticsSection from './sections/StatisticsSection';
import CTASection from './sections/CTASection';
import BlogSection from './sections/BlogSection';
import Footer from './components/Footer';

function App() {
  return (
    <>
      <Navbar />
      <HeroSection />
      <ServicesSection />
      <VideoBusinessSection />
      <FeaturedServicesGrid />
      <FeaturesSection />
      <WhyChooseUs />
      <CaseStudies />
      <TeamSection />
      <ConsultationSection />
      <StatisticsSection />
      <CTASection />
      <BlogSection />
      <Footer />
    </>
  );
}

export default App;