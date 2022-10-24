package com.google.ar.core.examples.java.webapi;

import android.graphics.Bitmap;

import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;

public class WebApiThread {
    private ExecutorService executorService;
    private WebApi webApi;

    private String accessToken;

    private WebApiThread() {
        this.executorService = Executors.newSingleThreadExecutor();
        this.webApi = new WebApi();
    }

    public void setToken(String accessToken) {
        this.accessToken = accessToken;
    }

    public synchronized <T> Future<T> get(String uri, Class<T> tClass) throws Exception {
        return this.get(uri, this.accessToken, tClass);
    }

    public synchronized <T> Future<T> get(String uri, String accessToken, Class<T> tClass) throws Exception {
        return executorService.submit(() -> webApi.get(uri, accessToken, tClass));
    }

    public synchronized Future<Bitmap> getImageFromURL(String uri) {
        return executorService.submit(() -> webApi.getImageFromURL(uri));
    }

    public synchronized <T> void post(String uri, T object, Class<T> tClass) {
        this.post(uri, this.accessToken, object, tClass);
    }

    public synchronized <T> void post(String uri, String accessToken, T object, Class<T> tClass) {
        executorService.submit(() -> {
            try {
                webApi.post(uri, accessToken, object, tClass);
            } catch (Exception e) {
                e.printStackTrace();
            }
        });
    }

    private static WebApiThread instance;

    public static WebApiThread getInstance() {
        if (instance == null) {
            instance = new WebApiThread();
        }
        return instance;
    }
}
