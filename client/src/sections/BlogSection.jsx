import React from 'react';
import { motion } from 'framer-motion';
import { Calendar, ArrowRight } from 'lucide-react';

const blogPosts = [
  {
    id: 1,
    image: 'https://images.unsplash.com/photo-1455849318743-b2233052fcff?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'The Future of Web Development in 2026',
    date: 'May 10, 2026',
    excerpt: 'Explore the latest trends and technologies shaping the web development landscape for businesses.',
  },
  {
    id: 2,
    image: 'https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'Mobile App Security: Best Practices',
    date: 'May 5, 2026',
    excerpt: 'Learn how to secure your mobile applications against common vulnerabilities and threats.',
  },
  {
    id: 3,
    image: 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&w=600&q=80',
    title: 'UI/UX Design Principles for Better Conversion',
    date: 'April 28, 2026',
    excerpt: 'Discover how effective design can improve user engagement and conversion rates significantly.',
  },
];

const BlogSection = () => {
  return (
    <section className="bg-light-blue py-20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-14"
        >
          <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-white px-4 py-1.5 rounded-full shadow-sm">
            Latest News
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2] mb-4">
            Read Our Latest News<br />& Blog
          </h2>
          <p className="text-gray-text text-base max-w-xl mx-auto">
            Stay updated with the latest insights, tips, and news from our team of experts.
          </p>
        </motion.div>

        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {blogPosts.map((post, i) => (
            <motion.div
              key={post.id}
              initial={{ y: 40, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              transition={{ duration: 0.6, delay: i * 0.1 }}
              viewport={{ once: true }}
              className="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-lg hover:-translate-y-2 transition-all duration-400 border border-border-light/50"
            >
              <div className="relative h-48 overflow-hidden">
                <img
                  src={post.image}
                  alt={post.title}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute top-3 left-3 bg-primary/90 text-white text-xs font-semibold px-3 py-1 rounded-full">
                  {post.category || 'General'}
                </div>
              </div>
              <div className="p-6">
                <div className="flex items-center gap-1.5 text-gray-text text-xs mb-3">
                  <Calendar className="w-3.5 h-3.5" />
                  <span>{post.date}</span>
                </div>
                <h3 className="text-base font-semibold text-dark-navy mb-2 leading-snug group-hover:text-primary transition-colors">
                  {post.title}
                </h3>
                <p className="text-gray-text text-sm leading-relaxed mb-4">{post.excerpt}</p>
                <a href="#" className="inline-flex items-center gap-1.5 text-primary text-xs font-semibold hover:gap-2 transition-all duration-300">
                  Read More <ArrowRight className="w-3.5 h-3.5" />
                </a>
              </div>
            </motion.div>
          ))}
        </div>

        <motion.div
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          viewport={{ once: true }}
          className="text-center mt-10"
        >
          <button className="border-2 border-primary text-primary px-8 py-3 rounded-full font-semibold text-sm hover:bg-primary hover:text-white transition-all duration-300 hover:shadow-lg hover:shadow-primary/25">
            View All Posts →
          </button>
        </motion.div>
      </div>
    </section>
  );
};

export default BlogSection;