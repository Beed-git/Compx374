package com.google.ar.core.examples.java.common.rendering;

import java.io.Closeable;

public interface ITexture extends Closeable {
    int getTextureId();
    int getWidth();
    int getHeight();
    void bind();
}
